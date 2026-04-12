# laravel-sample

Laravel + Docker で構築したポートフォリオ公開用プロジェクトです。

English version: [README.md](README.md)

## 技術スタック

- PHP 8.4
- Laravel 12
- MySQL 8.4
- Nginx
- Docker / Docker Compose

## プロジェクト構成

```
.
├── .docker/                    # Docker関連の設定ファイル
│   ├── nginx/                  # Nginx設定
│   │   └── default.conf        # HTTP設定
│   └── php/                    # PHP設定
│       ├── Dockerfile          # PHPコンテナのビルド定義
│       ├── docker-entrypoint.sh # コンテナ起動時の初期化スクリプト
│       └── php.ini             # PHP設定
├── .github/                    # GitHub Actions設定
├── app/                        # Laravelアプリケーション（標準構成）
├── docker-compose.yml          # ローカル環境用Docker Compose設定
└── ...                         # その他Laravelプロジェクトファイル
```

- `.docker/`: Docker コンテナのビルド設定をサービス別に管理します。
    - `nginx/`: Web サーバーとして Nginx を使用しており、HTTP 設定ファイルがあります。
    - `php/`: PHP-FPM コンテナのビルド定義・設定。
- `docker-compose.yml`: ローカル環境用。サービスは `nginx`、`php`（PHP-FPM）、`db`（MySQL）があります。
- Laravel プロジェクトのファイルはプロジェクトルート直下に配置されています。

## ローカル環境のセットアップ

### 前提条件

- Docker / Docker Compose がインストールされていること

### 起動手順

以下のコマンドを**プロジェクトルート**で実行してください。

#### 1. コンテナの起動

```bash
docker compose up -d
```

#### 2. 依存パッケージのインストール

```bash
docker compose exec php composer install -o
```

#### 3. 環境設定ファイルの作成

```bash
docker compose exec php cp .env.example .env
docker compose exec php php artisan key:generate
```

#### 4. データベースのマイグレーション

```bash
docker compose exec php php artisan migrate
```

### アクセス

| URL                   | 説明   |
|-----------------------|------|
| http://localhost:8080 | HTTP |

### DB 接続情報（ローカル）

| 項目       | 値                 |
|----------|-------------------|
| Host     | 127.0.0.1         |
| Port     | 3306              |
| Database | laravel_sample_db |
| User     | username          |
| Password | password          |

### DB コンテナのリフレッシュ

DB ボリュームを削除してコンテナを再起動する場合は以下を実行します。

```bash
docker compose down -v && docker compose up -d
```

## ビルド & テスト

PHP（Laravel）はバックエンド側のビルド不要です（JIT コンパイラによる実行時コンパイル）。

`php artisan` コマンド及び `npm` 系コマンドはすべてコンテナ内で実行します。

### バックエンドテスト

```bash
docker compose exec php php artisan test
```

### フロントエンドビルド（必要に応じて）

```bash
docker compose exec php npm run build
```

### フロントエンドテスト（必要に応じて）

```bash
docker compose exec php npm run test
```
