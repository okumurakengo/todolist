# todolist

## version
phpのバージョン7以上をインストールしてください。

---

## git clone
todolistをインストールしたいディレクトリで以下のコマンドを実行

```
git clone git@github.com:okumurakengo/todolist.git
cd todolist
php composer.phar install
```

todolistフォルダの中にvendorフォルダができていればOK

---

## 実行

続けて以下のコマンドを実行

```
php -S 127.0.0.1:8000 router.php
```

http://127.0.0.1:8000
にアクセスするとtodolistを起動できます。(初期状態はtodoのデータがないので新規作成ボタンで追加してください。)

![todolist](https://github.com/okumurakengo/images/blob/master/todolist.png "todolist")
