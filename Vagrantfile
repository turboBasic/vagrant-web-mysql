DEFAULT_BOX = "bento/ubuntu-18.04"
DEFAULT_MEMORY = '1024'
DEFAULT_CPUS = '1'
DEFAULT_PLAYBOOK = 'provision/site.yml'
DEFAULT_INVENTORY = {
  "webservers" => [ "web" ],
  "dbservers" => [ "db" ],
  "all_groups:children" => [
      "webservers",
      "dbservers"
  ],
  "all:vars" => {}
}

boxes = [
  { name: 'web',
    primary: true,
    ip: '192.168.50.4',
    cpus: 2,
    synced_folder: {
      src: './html',
      dest: '/var/www/html',
      options: {
        owner: 'root',
        group: 'root'
      }
    }
  },
  { :name => 'db',
    :ip => '192.168.50.5',
    :memory => 2048,
    :cpus => 2
  }
]

ansible_provisions = [
  {
    playbook: "provision/site.yml",
    verbose: "vv",
    groups: {
      "webservers" => [ "web" ],
      "all_groups:children" => [
          "webservers"
      ],
      "all:vars" => {}
    }
  },
  {
    groups: {
      "dbservers" => [ "db" ],
      "all_groups:children" => [
          "dbservers"
      ]
    }
  }
]


def custom_synced_folders(vm, host)
  if host.has_key?('synced_folder')
    folders = host['synced_folder']

    folders.each do |folder|
      vm.synced_folder folder['src'], folder['dest'], folder['options']
    end
  end
end




Vagrant.configure("2") do |config|
  boxes.each do |host|
    config.vm.define host[:name], primary: host[:primary] do |subconfig|
      subconfig.vm.box = host[:box] ||= DEFAULT_BOX
      subconfig.vm.box_check_update = false
      subconfig.vm.hostname = host[:name]
      subconfig.vm.network :private_network, ip: host[:ip]
      custom_synced_folders(subconfig.vm, host)

      subconfig.vm.provider :virtualbox do |vb|
        vb.name = host[:name]
        vb.memory = host[:memory] ||= DEFAULT_MEMORY
        vb.cpus = host[:cpus] ||= DEFAULT_CPUS
      end
    end
  end

  ansible_provisions.each do |provision|
    config.vm.provision "ansible" do |ansible|
      ansible.playbook = provision[:playbook] ||= DEFAULT_PLAYBOOK
      ansible.verbose = provision[:verbose] ||= true
      ansible.groups = provision[:groups] ||= DEFAULT_INVENTORY
    end
  end

end
