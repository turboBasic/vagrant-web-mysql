Vagrant.configure("2") do |config|

  config.vm.define "web", primary: true do |web|
    web.vm.box = "bento/ubuntu-18.04"
    web.vm.box_check_update = false

    web.vm.hostname = "web"
    web.vm.network "private_network", ip: "192.168.50.4"
    web.vm.synced_folder "./html", "/var/www/html", owner: "root", group: "root"

    web.vm.provider "virtualbox" do |vb|
        vb.name = "web"
        vb.memory = "1024"
        vb.cpus = "2"
    end


    web.vm.provision "ansible" do |ansible|
      ansible.playbook = "provision/site.yml"
      ansible.verbose = true

      ansible.groups = {
        "webservers" => [ "web" ],
        "dbservers" => [ "db" ],
        "all_groups:children" => [
            "webservers",
            "dbservers"
        ],
        "all:vars" => {}
      }
    end
  end

  config.vm.define "db", primary: true do |db|
    db.vm.box = "bento/ubuntu-18.04"
    db.vm.box_check_update = false

    db.vm.hostname = "db"
    db.vm.network "private_network", ip: "192.168.50.5"

    db.vm.provider "virtualbox" do |vb|
        vb.name = "db"
        vb.memory = "1024"
        vb.cpus = "2"
    end


    db.vm.provision "ansible" do |ansible|
      ansible.playbook = "provision/site.yml"
      ansible.verbose = true

      ansible.groups = {
        "webservers" => [ "web" ],
        "dbservers" => [ "db" ],
        "all_groups:children" => [
            "webservers",
            "dbservers"
        ],
        "all:vars" => {}
      }
    end
  end

end
