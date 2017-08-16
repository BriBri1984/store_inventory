VAGRANTFILE_API_VERSION = "2"

app_path="/var/www/app"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

    config.vm.box = "ubuntu/trusty64"
    config.vm.hostname = "store.local"

    config.vm.synced_folder ".", app_path
    config.vm.network "private_network", ip: "10.10.10.123"

    # Disable the new default behavior introduced in Vagrant 1.7, to
    # ensure that all Vagrant machines will use the same SSH key pair.
    # See https://github.com/mitchellh/vagrant/issues/5005
    config.ssh.insert_key = false

    # Automatically detect system configuration and set resource limits on vm
    config.vm.provider "virtualbox" do |v|

        host = RbConfig::CONFIG['host_os']

        # Give VM 1/2 system memory & access to 1 cpu core on the host
        # Read this https://stefanwrobel.com/how-to-make-vagrant-performance-not-suck
        if host =~ /darwin/
            # sysctl returns Bytes and we need to convert to MB
            mem = `sysctl -n hw.memsize`.to_i / 1024 / 1024 / 4
        elsif host =~ /linux/
            # meminfo shows KB and we need to convert to MB
            mem = `grep 'MemTotal' /proc/meminfo | sed -e 's/MemTotal://' -e 's/ kB//'`.to_i / 1024 / 4
        else
            mem = 1024
        end
        v.gui = false
        v.customize ["modifyvm", :id, "--memory", mem]
        v.customize ["modifyvm", :id, "--cpus", 1]
        v.customize ["modifyvm", :id, "--ioapic", "on"]
    end

    # Copy private key to VM for SSH interactions
    config.vm.provision "file", source: "~/.ssh/id_rsa", destination: "~/.ssh/id_rsa"

    # Use ansible to provision the virtual machine in it's entirety
    config.vm.provision "ansible_local" do |ansible|
        ansible.install_mode = 'pip'
        ansible.version = '2.3.0.0'
        ansible.provisioning_path = "#{app_path}/devops"
        ansible.galaxy_role_file = "#{app_path}/devops/requirements.yml"
        ansible.galaxy_roles_path = "#{app_path}/devops/roles.galaxy"
        ansible.limit = 'all'
        # ansible.verbose = "v"
        ansible.inventory_path = "#{app_path}/devops/hosts/dev"
        ansible.playbook = "#{app_path}/devops/vm.yml"
        ansible.extra_vars = {
            app_url: 'store.local',
            ansible_ssh_user: 'vagrant',
            symfony_env: 'dev',
            nginx_user: 'vagrant',
            resque_http_user: 'resque',
            resque_http_pass: 'ResqueI5C0o1',
            resque_http_port: 5679,
            redis_ip: '127.0.0.1',
            redis_port: 6379,
            varnish_dashboard: true,
            varnish_ha: false
        }
    end

    if Vagrant.has_plugin?("vagrant-cachier")
        config.cache.scope = :box
    end

end

