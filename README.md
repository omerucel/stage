# Hakkında

Docker destekli [Continues Testing](https://continuousdelivery.com/foundations/test-automation/) aracı.

# Kullanımı

İlgili projenin kök dizininde **stage.yml** isimli dosya oluşturulmalı.

```yaml
default:
    output_dir:
        - var/output
        - var/logs

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
$ php bin/stage.php build --docker-compose-bin="/usr/local/bin/docker-compose" \
--docker-bin="/usr/local/bin/docker" \
--builds-dir="/Users/omerucel/Downloads/builds" \
--outputs-dir="/Users/omerucel/Downloads/outputs" \
--project-dir="/Users/omerucel/Data/Dev/Projects/test-project" \
--dry
```

Bu komutun şu parametreleri alır:
* --docker-bin: docker çalıştırılabilir dosyasının bulunduğu konum.
* --docker-compose-bin: docker-compose çalıştırılabilir dosyasının bulunduğu konum.
* --builds-dir: Proje dizini belirtilen konuma geçici olarak kopyalanır. Her bir projenin geçici dizin adı farklıdır ve otomatik olarak tanımlanır.
* --outputs-dir: Test çıktılarının kopyalanacağı konum. Her bir projenin geçici dizin adı farklıdır ve otomatik olarak tanımlanır.
* --project-dir: Projenin kaynak kodlarının bulunduğu dizin.
* --dry: Yapılacak işlemlerin çıktısını ekrana yazar.

