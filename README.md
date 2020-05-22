# Docker Laravel

## 事前準備

docker, docker-composeを使用しますので、事前にインストールをしてください。  

### インストール参考

- [docker と docker-compose の初歩](https://qiita.com/hiyuzawa/items/81490020568417d85e86) ※mac

- [[Docker] Windows 10 Pro 64bit に Docker と Docker Compose をインストールする](https://qiita.com/ksh-fthr/items/6b1242c010fac7395a45) ※win

### インストール確認

```bash
$ docker version
Docker version 19.03.8, build afacb8b

$ docker-compose --version
docker-compose version 1.25.4, build 8d51620a
```

インストールが完了して、dockerが起動していることが確認できれば、準備完了です。

## HOW TO START

### 1. 開発環境用の.env作成

ローカル環境用の環境変数ファイル生成用のシェルスクリプトを実行  
プロジェクトルートディレクトリで、

```bash
sh .sh/setup-local.sh
```

※今後`.sh/conf/.local-env`が更新した際は、上記スクリプトを再実行してください。

### 2. 開発環境用の証明書発行

開発環境用の自己証明書を発行してください

``` bash
cd docker/nginx/cert-key
brew install mkcert # mkcertが未インストールの場合
mkcert -install # mkcertが未インストールの場合
mkcert -cert-file ./localhost.crt.pem -key-file ./localhost.key.pem localhost local.laravel ${WEB_DOMAIN}
```

### 3. dockerアプリケーションの起動

```bash
$ docker-compose up -d
Recreating docker_laravel_db_1 ... done
Recreating docker_laravel_app_1        ... done
Recreating docker_laravel_phpmyadmin_1 ... done
Recreating docker_laravel_web_1        ... done
```

### 4. Laravelのインストール

#### 1. appコンテナにチェックアウト

```bash
# your pc
$ docker-compose exec app ash
```

#### 2. Laravelのインストール

```bash
# app container
$ composer create-project --prefer-dist "laravel/laravel" ./
```

#### 3. Laravelの環境変数ファイルの生成

1. `src/.env.example`を`src/.env`にリネーム

2. `src/.env`のDBの設定をdocker環境のdb接続情報と合わせる。

```src/.env
#src/.env

DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=docker_laravel
DB_USERNAME=docker_laravel
DB_PASSWORD=test
```

#### 4. dbの接続確認

```bash
# app container
$ php artisan migrate
```

### 5. 動作確認

[https://${WEB_DOMAIN}:${SSL_PORT}](https://${WEB_DOMAIN}:${SSL_PORT})にアクセスしてページが表示されればOKです。
