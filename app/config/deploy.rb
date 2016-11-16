set :application, "harnet"
set :domain,      "128.199.55.153"
set  :user,       "root"
set  :use_sudo,   true
default_run_options[:pty] = true
set :deploy_to,   "/home/harnet/public_html/www"
set :app_path,    "app"
set :web_path,    "web"

set :repository, "C:/wamp64/www/symfony2/hello"
set :deploy_via,  :copy
set :scm, :git

set :model_manager,  "doctrine"

role :web,        domain                         # Your HTTP server, Apache/etc
role :app,        domain                         # This may be the same as your `Web` server
role :db,         domain, :primary => true       # This is where Rails migrations will run

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_set_permissions, true
set :permission_method,   :acl
set :webserver_user,      "root"
set :file_permissions_paths, ["app/cache", "app/logs"]
set :writable_dirs,       ["app/cache", "app/logs"]

set :use_composer,  true
set :update_vendors, false
set :keep_releases,  3

 task :upload_parameters do
  origin_file = "app/config/parameters.yml"
  destination_file = shared_path + "/app/config/parameters.yml" # Notice the
  shared_path

  try_sudo "mkdir -p #{File.dirname(destination_file)}"
  top.upload(origin_file, destination_file)
end

after "deploy:setup", "upload_parameters"

#logger.level = Logger::MAX_LEVEL