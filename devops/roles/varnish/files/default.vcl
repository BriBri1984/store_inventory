# See the VCL chapters in the Users Guide at https://www.varnish-cache.org/docs/
# and http://varnish-cache.org/trac/wiki/VCLExamples for more examples.

# Marker to tell the VCL compiler that this VCL has been adapted to the
# new 4.0 format.
vcl 4.0;

import std;

# This acl is called "invalidators" and will be used to denote IPs that can invalidate content
# IPs in this list can make invalidation requests to PURGE and BAN
acl invalidators {
    "localhost";
    "127.0.0.1";
    "10.10.2.2"; # mac IP for node frontend
    "10.10.10.123"; # Vagrant IP
}

# API nginx backend
# What is new here is the probe. In this example Varnish will check the health of each backend every 5 seconds,
# timing out after 1 second. Each poll will send a GET request to /. If 3 out of the last 5 polls succeeded
# the backend is considered healthy, otherwise it will be marked as sick.
backend default {
    .host = "127.0.0.1";
    .port = "8000";
    .first_byte_timeout     = 60s;  # How long to wait before we receive a first byte from our backend?
    .connect_timeout        = 60s;   # How long to wait for a backend connection?
    .between_bytes_timeout  = 60s;   # How long to wait between bytes received from our backend?
}

sub vcl_recv {

    # Manual 2.0 to 3.0 Link Redirects @see https://flocasts.atlassian.net/wiki/spaces/3D/pages/74255240/2.0+to+3.0+Link+Redirects
    if (req.url ~ "^/people$") {
        return (synth(301, "/"));
    }
    # Eventually, we will build front end pages for People. They just aren't ready yet.
    if (req.url ~ "^/people/[0-9]+-([^/?]+)") { # Individual People Page
        return (synth(302, "/search?q=" + regsuball(regsub(req.url, "^/people/[0-9]+-([^/?]+).*$", "\1"), "-", "+")));
    }
    # This tab does not exist on 3.0.
    if (req.url ~ "^/events?/[^/]+/misc$") { # Event Hub - Custom "Info" Tab
        return (synth(302, regsub(req.url, "/events?/([^/]+)/misc$", "/events/\1")));
    }
    if (req.url ~ "^/(article|event|result|ranking)/.+") {
        return (synth(301, regsub(req.url, "/(article|event|result|ranking)/", "/\1s/")));
    }
    # Eventually we will build out a Technique section, and have Technique in the nav. But it's not ready yet. So we need a temp redirect to HOME.
    if (req.url ~ "^/videos/landing\?order=publish_date&direction=desc&categories=training") { # VLP - Training tab
        return (synth(302, "/"));
    }
    # This is the direct link to the Event Videos Tab of the VLP. We'll take them to the Events Landing Page instead.
    if (req.url ~ "^/videos/landing\?order=publish_date&direction=desc&categories=event\+tab") { # VLP - Event Tab
        return (synth(301, "/events/completed"));
    }
    # Eventually we will build out a Films section, and have Films in the nav. But it's not ready yet. So we need a temp redirect to HOME.
    if (req.url ~ "^/videos/landing\?order=publish_date&direction=desc&categories=flofilm") { # VLP - FloFilm Tab
        return (synth(302, "/"));
    }
    # Eventually we will build out a Series/Shows section, and have Shows in the nav. But it's not ready yet. So we need a temp redirect to HOME.
    if (req.url ~ "^/videos/landing\?order=publish_date&direction=desc&categories=series") { # VLP - Series Tab
        return (synth(302, "/"));
    }
    # We will not have a Videos landing page on 3.0. So redirect to HOME.
    if (req.url ~ "^/videos/landing") { # Videos Landing Page
        return (synth(302, "/"));
    }
    if (req.url ~ "^/settings/subscription") { # Account Settings - Subscription
        return (synth(301, "/account/subscriptions"));
    }
    if (req.url ~ "^/settings/changepw") { # Account Settings - Change Password
        return (synth(301, "/account/password"));
    }
    if (req.url ~ "^/settings/edit") { # Account Settings - Edit
        return (synth(301, "/account"));
    }
    if (req.url ~ "^/settings") { # Account Settings - Home (and catch-all)
        return (synth(301, "/account"));
    }

    # Remove Cache-Control header from client
    unset req.http.Cache-Control;

    # https://www.varnish-cache.org/docs/3.0/tutorial/purging.html
    # A purge is what happens when you pick out an object from the cache and discard it along with its variants.
    # Usually a purge is invoked through HTTP with the method PURGE.
    if (req.method == "PURGE") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }
        return (purge);
    }

    # Do not cache OPTIONS requests
    if (req.method == "OPTIONS") {
        set req.hash_always_miss = true;
    }

    # https://www.varnish-cache.org/trac/wiki/VCLExampleEnableForceRefresh
    if (req.http.Cache-Control ~ "no-cache" && client.ip ~ invalidators) {
        set req.hash_always_miss = true;
    }

    # https://varnish-cache.org/docs/4.0/users-guide/purging.html
    if (req.method == "BAN") {
        if (!client.ip ~ invalidators) {
            return (synth(405, "Not allowed"));
        }

        if (req.http.X-Cache-Tags) {
            ban("obj.http.X-Host ~ " + req.http.X-Host
                + " && obj.http.X-Url ~ " + req.http.X-Url
                + " && obj.http.content-type ~ " + req.http.X-Content-Type
                + " && obj.http.X-Cache-Tags ~ " + req.http.X-Cache-Tags
            );
        } else {
            ban("obj.http.X-Host ~ " + req.http.X-Host
                + " && obj.http.X-Url ~ " + req.http.X-Url
                + " && obj.http.content-type ~ " + req.http.X-Content-Type
            );
        }

        return (synth(200, "Banned"));
    }
}

# https://www.varnish-cache.org/docs/trunk/users-guide/vcl-grace.html
# When several clients are requesting the same page Varnish will send one request to the backend and place the others on
# hold while fetching one copy from the backend. In some products this is called request coalescing and Varnish does this automatically.
# If you are serving thousands of hits per second the queue of waiting requests can get huge.
# There are two potential problems - one is a thundering herd problem - suddenly releasing a thousand threads
# to serve content might send the load sky high. Secondly - nobody likes to wait.
# To deal with this we can instruct Varnish to keep the objects in cache beyond their TTL and to serve the waiting requests somewhat stale content.
sub vcl_hit {

    # normal hit
    if (obj.ttl >= 0s) {
        return (deliver);
    }

    # you can check if the backend is sick and only serve graced object then
    if (!std.healthy(req.backend_hint) && (obj.ttl + obj.grace > 0s)) {
        return (deliver);
    } else {
        return (miss);
    }
}

# Called after a cache lookup if the requested document was not found in the cache. Its purpose
# is to decide whether or not to attempt to retrieve the document from the backend, and which
# backend to use.
sub vcl_miss {
    return (fetch);
}

sub vcl_backend_response {

    # Set ban-lurker friendly custom headers
    set beresp.http.X-Url = bereq.url;
    set beresp.http.X-Host = bereq.http.host;

    # Make varnish keep all objects for `n` minutes above their smaxage TTL
    set beresp.grace = 2m;
}

sub vcl_synth {
    if (resp.status == 301) {
        set resp.http.location = resp.reason;
        set resp.reason = "Moved Permanently";
        return (deliver);
    }

    if (resp.status == 302) {
        set resp.http.location = resp.reason;
        set resp.reason = "Temporary Redirect";
        return (deliver);
    }
}

sub vcl_deliver {

    # Copy the grace header from the request object (req) to the response before delivering it.
    # set resp.http.grace = req.http.grace;

    # Add debug header to see if it's a HIT/MISS and the number of hits, disable when not needed
    if (obj.hits > 0) {
        set resp.http.X-Cache = "HIT";
    } else {
        set resp.http.X-Cache = "MISS";
    }
}
