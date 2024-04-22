# フリマアプリ
### 商品を出品、購入することができるアプリ

## 作成目的
coachtechブランドのアイテムを出品する(模擬)

## アプリケーションURL
- 開発環境：http://localhost/
- 本番環境：http://54.168.236.171
- phpMyAdmin：http://localhost:8080/
- MailHog：http://localhost:8025/

## テスト用アカウント（管理者権限あり）

        Email：test@test.com

        Pass ：123456789

## テスト用クレジットカード番号
        4242 4242 4242 4242

支払い機能で使用できるテスト用のクレジットカード番号です。<br>
有効期限、セキュリティコードに指定はありません。
## 機能一覧
<table>
<tr>
<th>
<div style="text-align: center;">
商品一覧ページ
</div>
</th>
<th>
<div style="text-align: center;">
検索結果表示ページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E5%95%86%E5%93%81%E4%B8%80%E8%A6%A7%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E6%A4%9C%E7%B4%A2%E7%B5%90%E6%9E%9C%E8%A1%A8%E7%A4%BA%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
</tr>
<tr>
<td>
おすすめとマイリストの表示の切り替えができます。<br>
おすすめは1週間以内に出品された商品が表示されます。
</td>
<td>
商品名、ブランド名、カテゴリー名の中から検索ができます。
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
商品詳細ページ
</div>
</th>
<th>
<div style="text-align: center;">
購入ページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E5%95%86%E5%93%81%E8%A9%B3%E7%B4%B0%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E8%B3%BC%E5%85%A5%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
</tr>
<tr>
<td>
星マーク、吹き出しマークをそれぞれ押すことで、<br>
マイリストやコメント機能にアクセスできます。
</td>
<td>
テスト用の銀行振込、コンビニ決済用のメールアドレス・電話番号は、
特に指定はありません
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
配送先変更ページ
</div>
</th>
<th>
<div style="text-align: center;">
マイページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E9%85%8D%E9%80%81%E5%85%88%E5%A4%89%E6%9B%B4%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%83%9E%E3%82%A4%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
</tr>
<tr>
<td>
プロフィールの住所とは別で配送専用の住所登録ができます。
</td>
<td>
出品した商品、購入した商品をそれぞれ切り替えて表示することができます。
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
プロフィール編集ページ
</div>
</th>
<th>
<div style="text-align: center;">
出品ページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%83%97%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB%E7%B7%A8%E9%9B%86%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E5%87%BA%E5%93%81%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
</tr>
<tr>
<td>
ここで登録した住所がデフォルトの配送先にもなります。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
管理ページ
</div>
</th>
<th>
<div style="text-align: center;">
会員登録ページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E7%AE%A1%E7%90%86%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E4%BC%9A%E5%93%A1%E7%99%BB%E9%8C%B2%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
</tr>
</tr>
<tr>
<td>
管理者権限の持つアカウントでのみこちらにアクセスできます。<br>
選択したユーザーに対し、削除やメール送信が行えます。
</td>
<td>
</td>
</tr>
</table>

<table>
<tr>
<th>
<div style="text-align: center;">
ログインページ
</div>
</th>
<th>
<div style="text-align: center;">
Stripeページ
</div>
</th>
</tr>
<tr>
<td>
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%83%AD%E3%82%B0%E3%82%A4%E3%83%B3%E3%83%9A%E3%83%BC%E3%82%B8.png">
</td>
<td>
<img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/stripe.png">
</td>
</tr>
<tr>
<td>
</td>
<td>
商品を出品する際に、アクセスします。<br>
テスト用の情報は各ページに用意されているのでそれを使用してください。<br>
「個人情報の確認」のフォームではテスト用の情報はないですが、
適当な情報で大丈夫です。
</td>
</tr>
</table>

## 使用技術
<table>
<tr>
<td>
フロントエンド
</td>
<td>
HTML , CSS , JavaScript
</td>
</tr>
<tr>
<td>
バックエンド
</td>
<td>
PHP：8.2 ,
Laravel：10.45.1 ,
MySQL：8.0.36
</td>
</tr>
<tr>
<td>
インフラ
</td>
<td>
Docker (開発環境) ,
AWS
</td>
</tr>
<tr>
<td>
CI/CD
</td>
<td>
Circle CI
</td>
</tr>     
<tr>
<td>
その他
</td>
<td>
Git , GitHub
</td>
</tr>
</table>

## テーブル設計
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88%202024-04-19%20143505.png">
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88%202024-04-19%20143520.png">
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88%202024-04-19%20143534.png">

## ER図
 <img src="https://raw.githubusercontent.com/nakagawa1573/images/main/market/market.drawio.png">

## 環境構築
### Dockerビルド
1.         git clone git@github.com:nakagawa1573/market.git
2.         docker-compose up -d --build

＊MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.ymlファイルを編集してください。

### Laravel環境構築
1.         docker-compose exec php bash
2.         composer install
3. .env.exampleファイルから.envを作成
4. .envを編集

        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=laravel_db
        DB_USERNAME=laravel_user
        DB_PASSWORD=laravel_pass
   
        MAIL_MAILER=smtp
        MAIL_HOST=mailhog
        MAIL_PORT=1025
        MAIL_USERNAME=null
        MAIL_PASSWORD=null
        MAIL_ENCRYPTION=null
        MAIL_FROM_ADDRESS="hello@example.com"
        MAIL_FROM_NAME="COACHTECHフリマ"

        STRIPE_KEY=Stripeの公開可能キー
        STRIPE_SECRET=Stripeのシークレットキー

        RETURN_URL= http://localhost/
4.         php artisan key:generate
5. もしマイグレーションとシーディングがされていなければ、自分で実行してください


           php artisan migrate --seed
8.         php artisan storage:link

## 本番環境
AWSを利用して構築
<table>
<tr>
<td>
バックエンド
</td>
<td>
EC2（Amazon Linux2）
</td>
</tr>
<tr>
<td>
データベース
</td>
<td>
RDS（MySQL）
</td>
</tr>
<tr>
<td>
ストレージ
</td>
<td>
S3
</td>
</tr>
</table>
