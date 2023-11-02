<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title></title>
    </head>
    <body>
        
        
        <?php
             //データベース名
            $dsn='mysql:dbname=tb250430db;host=localhost';
             //ユーザー名
            $user='tb-250430';
            //パスワード
            $password='n56muU8evm';
    
             //DB接続設定
            $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        
            $sql="CREATE TABLE IF NOT EXISTS tb5"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name CHAR(32),"
            . "comment TEXT,"
            . "date DATETIME,"
            . "pass TEXT"
            .");";
            $stmt = $pdo->query($sql);
            
            if(!empty($_POST["edit_num"]) && isset($_POST["pass2"]) && $_POST["pass2"]!=""){
                $edit_num = $_POST["edit_num"];
                $id = $_POST["edit_num"];
                $pass2 = $_POST["pass2"];
                
        
                $sql = 'SELECT * FROM tb5 WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();              
                $results = $stmt->fetchAll(); 
                foreach ($results as $row){
                    if ($pass2 == $row['pass']){
                        $datname = $row['name'];
                        $datcomment = $row['comment'];
                    }
                    
                }
                    
                
                
                
            }
            
            
        
        
        
        
        ?>
      
        <form action = "" method = "POST">
            <input type = "txt" name = "name" placeholder = "名前" value = <?php if(!empty($datname)){echo $datname;}?>>
            <input type = "txt" name = "comment" placeholder = "コメント" value = <?php if(!empty($datcomment)){echo $datcomment;}?>>
            <input type = "hidden" name = "renum" value = <?php if(!empty($edit_num)){echo $edit_num;}?>>
            <input type = "password" name = "pass" placeholder = "パスワード" >
            <input type = "submit" name = "submit"> <br>
            <input type = "txt" name = "delnum" placeholder = "削除対象番号">
            <input type = "password" name = "pass1" placeholder = "パスワード" >
            <input type = "submit" name = "del" value = "削除"> <br>
            <input type = "txt" name = "edit_num" placeholder = "編集対象番号">
            <input type = "password" name = "pass2" placeholder = "パスワード" >
            <input type = "submit" name = "editnum" value ="編集"><br>
            
        </form>
        <?php
            
            
             //データベース名
            $dsn='mysql:dbname=tb250430db;host=localhost';
             //ユーザー名
            $user='tb-250430';
            //パスワード
            $password='n56muU8evm';
    
             //DB接続設定
            $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
        
            $sql="CREATE TABLE IF NOT EXISTS tb5"
            ." ("
            . "id INT AUTO_INCREMENT PRIMARY KEY,"
            . "name CHAR(32),"
            . "comment TEXT,"
            ."date DATETIME,"
            ."pass TEXT"
            .");";
            $stmt = $pdo->query($sql);
            
           
            if (!empty($_POST["name"]) && !empty($_POST["comment"])){
                
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $date = date("Y/m/d H:i:s");
                $pass = $_POST["pass"];
                
                #編集投稿
                if(!empty($_POST["renum"])){
                    $id = $_POST["renum"]; //変更する投稿番号
                    $name = $_POST["name"];
                    $comment = $_POST["comment"];
                    $date = date("Y/m/d H:i:s");
                    $pass = $_POST["pass"];
                    
                    
                     //変更したい名前、変更したいコメントは自分で決めること
                    $sql = 'UPDATE tb5 SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                    
                    
                    $stmt->execute();
                
                 #新規投稿  
                }else if(empty($_POST["renum"])){
                    $sql = "INSERT INTO tb5 (name, comment,date,pass) VALUES (:name, :comment,:date,:pass)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                    $stmt->execute();
                
                }
                
                
                
                    
                    
            
                    
            }else if(!empty($_POST["delnum"]) && !is_null($_POST["pass1"]) && $_POST["pass1"]!=""){
                $id = $_POST["delnum"];
                $pass1 = $_POST["pass1"];
                
                $sql = 'SELECT * FROM tb5 WHERE id=:id ';
                $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
                $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
                $stmt->execute();              
                $results = $stmt->fetchAll(); 
                foreach ($results as $row){
                    if($pass1==$row['pass']){
                    $sql = 'delete from tb5 where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt->execute();
                    }
                }
                
            }
            
            $sql = 'SELECT * FROM tb5';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                 //$rowの中にはテーブルのカラム名が入る
                    echo $row['id']."&nbsp";
                    echo $row['name']."&nbsp";
                    echo $row['comment']."&nbsp";
                    echo $row['date'];
                    
    
                    
                echo "<hr>";
                }
            
            
        
        ?> 
    </body>
</html>