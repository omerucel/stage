# Hakkında

Docker destekli [Continuous Testing](https://continuousdelivery.com/foundations/test-automation/) aracı.

# Kullanımı

Ortam ayarları ve proje ayarları için iki adet yaml dosyasına ihtiyaç var. Ortam ayarları dosyası testlerin çalışacağı 
sunucuda oluşturulmalı. Örnek ayar dosyası:

```yaml
builds_dir: /builds
output_dir: /outputs
docker_compose_bin: /usr/local/bin/docker-compose
docker_bin: /usr/local/bin/docker
notification:
    slack:
        webhook_url: https://hooks.slack.com/services/X/Y/Z
        username: stage
        icon_emoji: ":rocket:"
```

Proje ayarları dosyası ise ilgili projenin kök dizininde **stage.yml** ismi ile oluşturulmalı. Örnek proje ayar dosyası:
```yaml
default:
    output_dir:
        - var/output
        - var/logs
    notification:
        slack:
            channel_name: "#stage-ci-test"

dockerfile:
    type: DockerFile
    dockerfile: Dockerfile
    source_code_target: /app
    command: sh /app/test_dockerfile.sh

dockercompose:
    type: DockerCompose
    docker_compose_file: docker-compose.yml
    service_name: app
    command: sh /data/project/test_dockercompose.sh

dockerimage:
    type: DockerImage
    dockerimage: php:7.1-apache
    source_code_target: /var/www/html
    command: sh /var/www/html/test_dockerimage.sh
```

Ardından konsol komutu aşağıdaki şekilde çalıştırılmalı:

```bash
$ php bin/stage.php build \
--environment-file="/Users/omerucel/Data/Dev/Projects/test-project/environment.yml" \
--project-dir="/Users/omerucel/Data/Dev/Projects/test-project" \
--dry
```

Bu komut şu parametreleri alır:
* --environment-file: Sunucu ortamı ayar dosyası.
* --project-dir: Projenin kaynak kodlarının bulunduğu dizin.
* --dry: Yapılacak işlemlerin çıktısını ekrana yazar.

