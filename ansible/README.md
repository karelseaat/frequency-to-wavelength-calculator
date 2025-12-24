# Ansible Deployment Playbooks

This directory contains Ansible playbooks for deploying the Frequency to Wavelength Calculator application to production servers.

## Prerequisites

- Ansible >= 2.9
- SSH access to target servers
- Target servers should be running Ubuntu 20.04 LTS or similar
- A user account with sudo privileges on target servers

## Setup

1. Install Ansible requirements:
```bash
ansible-galaxy install -r requirements.yml
```

2. Update the inventory file with your server details:
```bash
vim inventory.ini
```

Update the following:
- `your_server_ip`: IP address or hostname of your server
- `ansible_user`: Username for SSH connection (default: deploy)
- `repo_url`: Your repository URL
- `repo_branch`: Git branch to deploy (default: main)

3. (Optional) Create SSH keys for passwordless authentication:
```bash
ssh-keygen -t rsa -b 4096 -f ~/.ssh/id_rsa
```

## Directory Structure

```
ansible/
├── deploy.yml                 # Main deployment playbook
├── inventory.ini              # Ansible inventory file
├── ansible.cfg               # Ansible configuration
├── requirements.yml          # Required Ansible collections
├── roles/
│   └── deploy/
│       ├── setup/            # Initial setup tasks
│       ├── dependencies/      # Install system dependencies
│       ├── clone_repo/       # Clone repository
│       ├── configure_app/    # Configure application
│       ├── install_dependencies/ # Install PHP/Node dependencies
│       └── nginx/            # Configure Nginx
└── README.md                 # This file
```

## Deployment

### Full Deployment

Deploy the application to all servers:

```bash
ansible-playbook deploy.yml
```

### Deploy to Specific Host

Deploy to a specific server:

```bash
ansible-playbook deploy.yml -i inventory.ini -l web1
```

### Dry Run

Run playbook without making changes:

```bash
ansible-playbook deploy.yml --check
```

### Verbose Output

For debugging, use verbose flags:

```bash
ansible-playbook deploy.yml -vv
```

## Configuration

### Environment Variables

Edit the `.env` file configuration in `roles/deploy/configure_app/templates/env.j2` to customize:

- `APP_URL`: Application URL
- `DB_CONNECTION`: Database type (sqlite, mysql, postgresql)
- `LOG_LEVEL`: Logging level
- Other Laravel environment variables

### Nginx Configuration

Customize Nginx settings in `roles/deploy/nginx/templates/nginx.conf.j2`:

- Server name and port
- PHP-FPM configuration
- SSL/TLS settings
- Gzip compression
- Cache headers

### PHP Version

Change PHP version in `deploy.yml`:

```yaml
vars:
  php_version: "8.2"  # Modify this
  node_version: "18"  # Modify this
```

## Roles

### setup
- Creates application directory structure
- Sets up deployment user
- Configures SSH keys

### dependencies
- Installs system packages (git, curl, supervisor, etc.)
- Installs PHP 8.2 and required extensions
- Installs Nginx
- Installs Node.js
- Installs Composer

### clone_repo
- Clones the repository from Git
- Sets proper file permissions

### configure_app
- Copies .env configuration
- Generates Laravel application key
- Clears application cache

### install_dependencies
- Runs Composer install
- Runs npm install
- Builds frontend assets with Vite
- Runs database migrations
- Caches configuration and routes

### nginx
- Creates Nginx server configuration
- Enables the site
- Configures PHP-FPM upstream
- Sets up logging and security headers

## SSL/TLS Configuration

To enable HTTPS with Let's Encrypt:

```bash
# On the target server, run:
sudo certbot --nginx -d your-domain.com
```

Or add an Ansible task to `roles/deploy/nginx/tasks/main.yml`:

```yaml
- name: Setup SSL with Let's Encrypt
  shell: certbot --nginx -d {{ inventory_hostname }} --non-interactive --agree-tos -m admin@example.com
```

## Troubleshooting

### Connection Issues

```bash
# Test connectivity to servers
ansible all -i inventory.ini -m ping

# Test with verbose output
ansible all -i inventory.ini -m ping -vv
```

### Permission Denied

Ensure the deploy user exists and has sudo access:

```bash
ssh deploy@your_server_ip sudo whoami
```

### Application Errors

Check logs on the server:

```bash
# PHP-FPM logs
sudo tail -f /var/log/php*.log

# Nginx logs
sudo tail -f /var/log/nginx/frequency-calculator_error.log

# Laravel logs
tail -f /var/www/frequency-calculator/storage/logs/laravel.log
```

## Monitoring

After deployment, monitor the application:

```bash
# SSH to server
ssh deploy@your_server_ip

# Check Laravel logs
tail -f /var/www/frequency-calculator/storage/logs/laravel.log

# Check service status
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
```

## Variables Reference

Key variables used in the playbooks:

- `app_name`: Application name (frequency-to-wavelength-calculator)
- `app_user`: User running the application (www-data)
- `app_path`: Application directory (/var/www/frequency-calculator)
- `repo_url`: Repository URL
- `repo_branch`: Git branch to deploy
- `php_version`: PHP version (8.2)
- `node_version`: Node.js version (18)

These can be customized in `inventory.ini` or directly in `deploy.yml`.

## Best Practices

1. **Always test on a staging environment first**
2. **Use version control for your inventory and playbooks**
3. **Keep sensitive data (IPs, passwords) out of version control** - use Ansible Vault or environment variables
4. **Regular backups**: Add backup roles before deployment
5. **Monitor logs** after deployment
6. **Use idempotent playbooks** - safe to run multiple times
7. **Document any customizations** to playbooks

## Rolling Updates

For multiple servers, use serial deployment:

```bash
ansible-playbook deploy.yml -i inventory.ini --serial=1
```

This deploys to one server at a time, reducing downtime.

## Support

For issues or questions:

1. Check the Ansible documentation: https://docs.ansible.com/
2. Review server logs
3. Test with `--check` flag before deployment
4. Use `-vv` or `-vvv` for verbose debugging

## License

These playbooks are part of the Frequency to Wavelength Calculator project and are licensed under the MIT License.
