# laravel-sample

Laravel + Docker で構築したポートフォリオ公開用プロジェクトです。

English version: [README.md](README.md)

## 技術スタック

- PHP 8.4
- Laravel 12
- MySQL 8.4
- Apache
- Docker / Docker Compose

## プロジェクト構成

```
.
├── .docker/                    # Docker関連の設定ファイル
│   ├── apache/                 # Apache設定
│   │   └── 000-default.conf    # HTTP設定
│   └── php/                    # PHP設定
│       ├── Dockerfile          # PHPコンテナのビルド定義
│       └── php.ini             # PHP設定
├── .github/                    # GitHub Actions設定
├── appRoot/                    # Laravelプロジェクトルート
├── docker-compose.yml          # ローカル環境用Docker Compose設定
└── Dockerfile                  # 本番環境用Dockerイメージビルド定義
```

- `.docker/`: Docker コンテナのビルド設定をサービス別に管理します。
    - `apache/`: Web サーバーとして Apache を使用しており、HTTP 対応の設定ファイルがあります。
    - `php/`: PHP コンテナのビルド定義・設定。
- `appRoot/`: アプリケーションルートです。Laravel プロジェクトの構成は標準通りです。
- `docker-compose.yml`: ローカル環境用。サービスは `web`（Apache + PHP）と `db`（MySQL）があります。
- `Dockerfile`: 本番環境用の Docker イメージビルド定義です。

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
docker compose exec web composer install -o
```

#### 3. 環境設定ファイルの作成

```bash
docker compose exec web cp .env.example .env
docker compose exec web php artisan key:generate
```

#### 4. データベースのマイグレーション

```bash
docker compose exec web php artisan migrate
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
docker compose exec web php artisan test
```

### フロントエンドビルド（必要に応じて）

```bash
docker compose exec web npm run build
```

### フロントエンドテスト（必要に応じて）

```bash
docker compose exec web npm run test
```
