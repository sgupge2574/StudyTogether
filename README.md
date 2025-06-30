# StudyTogether

**StudyTogether** は、チームでの勉強会を簡単にスケジューリング・参加できる Web アプリケーションです。チーム名と名前だけでログインし、勉強会の投稿・参加管理ができます。

---
## リンク
[StudyTogether](https://tech-base.net/tb-270118/misssion6/login.php)
## 💡 主な機能

- チーム名 + 名前によるログイン（パスワード不要）
- 勉強会の投稿（タイトル・内容・日時）
- チーム内メンバーによる投稿の一覧表示
- 「参加する」ボタンで参加表明
- 参加者一覧の表示（重複除外）

---

## 🗂 ファイル構成

| ファイル名        | 説明                           |
|------------------|--------------------------------|
| `login.php`      | ログイン画面（チーム名＋名前） |
| `register.php`   | ユーザー登録画面               |
| `post.php`       | 勉強会の投稿ページ             |
| `list.php`       | 投稿一覧＋参加機能             |
| `logout.php`     | ログアウト処理                 |
| `db.php`         | データベース接続ファイル       |
| `header.php`     | ナビゲーション用共通パーツ     |
| `style.css`      | 共通スタイルシート             |

---

## 🛠 データベース構成

### `users` テーブル

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    team_name VARCHAR(100) NOT NULL
);
```

### `posts` テーブル

勉強会の投稿内容を管理します。

```sql
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    datetime DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

| カラム名   | 型            | 説明                     |
|------------|----------------|--------------------------|
| id         | INT            | 投稿ID（主キー）         |
| user_id    | INT            | 投稿したユーザーのID     |
| title      | VARCHAR(255)   | 投稿のタイトル           |
| content    | TEXT           | 投稿内容                 |
| datetime   | DATETIME       | 勉強会開催日時           |

---

### `participants` テーブル

投稿に対して「参加する」ユーザーの情報を記録します。

```sql
CREATE TABLE participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    UNIQUE(user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

| カラム名   | 型    | 説明                           |
|------------|--------|--------------------------------|
| id         | INT    | 参加記録ID（主キー）           |
| user_id    | INT    | 参加者ユーザーのID             |
| post_id    | INT    | 対象投稿（勉強会）のID         |
| UNIQUE(user_id, post_id) |     | 同じ投稿に同じユーザーが重複登録されない |

---

## 🚀 使い方

1. `register.php` から名前とチーム名を登録
2. `login.php` から同じ情報でログイン
3. `post.php` で勉強会を投稿
4. `list.php` にてチーム内の投稿が一覧表示され、参加可能

---

## 🎨 スタイル

共通のスタイルは `style.css` に記述。ページごとのレイアウトも柔軟に調整できるよう、クラスごとの分離設計を採用しています。

---

## 📌 備考

- パスワードは使用していません。シンプルな操作性を重視しています。
- 同じチーム名のユーザー同士でのみ、投稿と参加が共有されます。
![image](https://github.com/user-attachments/assets/1a1b4521-3577-45e2-983d-45c3454ee1f0)
![image](https://github.com/user-attachments/assets/1f4c1620-e29e-4e7c-bcdf-fb4c115c9388)
![image](https://github.com/user-attachments/assets/34592f2b-923f-46da-89ef-47cbf991060b)
![image](https://github.com/user-attachments/assets/055d31d6-2919-4ee8-8c5b-779d0dfdc526)



