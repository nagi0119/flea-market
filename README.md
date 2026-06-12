# flea-market

フリマアプリを模したECサイトです。

会員登録、ログイン、商品出品、商品購入、いいね、コメント、プロフィール編集、メール認証、Stripe決済機能を実装しています。

## 環境構築

### Dockerビルド

1. リポジトリをクローン

```bash
git clone git@github.com:nagi0119/flea-market.git
``` 
2. DockerDesktopアプリを立ち上げる

3. コンテナを起動
```bash
docker-compose up -d --build
```

### 使用コンテナ

- Nginx: nginx:1.21.1
- MySQL: mysql:8.0.26
- phpMyAdmin: phpmyadmin/phpmyadmin

### Laravel環境構築

1. コンテナに入る
```bash
docker-compose exec php bash
```
2. composerをインストール
```bash
composer install
```
3. .env.example をコピーして .env を作成
```bash
cp .env.example .env
```
4. .envに以下の環境変数を追加
```bash
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
```bash
php artisan key:generate
```
6. マイグレーションの実行
```bash
php artisan migrate
```
7. シーディングの実行
```bash
php artisan db:seed
```
8. シンボリックリンク作成
```bash
php artisan storage:link
```

## 使用技術（実行環境）
- PHP 8.1.34
- Laravel 8.83.8
- MySQL 8.0.26
- Docker
- Fortify
- Stripe

## URL

- 環境開発: http://localhost
- phpMyAdmin: http://localhost:8080/
- MailHog: http://localhost:8025

---

## ER図
![ER図](./er.png)

---

## 実装機能
- 会員登録
- ログイン
- ログアウト
- メール認証
- 商品一覧
- 商品検索
- 商品詳細
- いいね機能
- コメント機能
- 商品購入
- Stripe決済
- 配送先変更
- プロフィール編集
- 商品出品

## テスト
```bash
docker-compose exec php php artisan test
```
実行結果
- 40 tests passed

## メール認証

MailHogを使用

認証メール確認

http://localhost:8025

## 決済

Stripe Checkoutを利用した決済機能を実装