# Frequency Converter

A no-frills PHP class for converting between frequency units. I built this because I needed a reliable, dependency-free solution for a radio project—and kept it simple so others could drop it in quickly.

## What it does

- Converts **Hz**, **kHz**, **MHz**, and **GHz**—back and forth.
- Zero configuration. Just instantiate and call `convert()`.

## Usage

```php
<?php
require_once 'FrequencyConverter.php';

$converter = new FrequencyConverter();

// 1 MHz → GHz
$frequencyInGHz = $converter->convert(1, 'MHz', 'GHz'); // 0.001

// 2.4 GHz → kHz
$frequencyInkHz = $converter->convert(2.4, 'GHz', 'kHz'); // 2400000
```

## Deploy

Ansible playbooks handle production deployments. See [ansible/README.md](ansible/README.md) for details.

Quick start:

```bash
cd ansible
vim inventory.ini      # add your servers
ansible-playbook deploy.yml
```

## Contribute

Want to improve it? Fork, hack, test, and send a PR. Keep PRs focused—no feature bloat.

## License

MIT. Do what you want with it.