<?php
    if (!empty($errors)) :
?>
    <div class="errors">
        <p>등록할 수 없습니다. 다음을 확인해주세요.</p>
        <ul>
            <?php
                foreach ($errors as $error) :
            ?>
                <li><?= $error ?></li>
            <?php
                endforeach;
            ?>
        </ul>
    </div>
<?php
    endif;
?>
<form action="" method="POST">
    <label for="email">이메일</label>
    <input name="author[email]" id="email" type="text" value="<?=$author['email'] ?? ''?>">

    <label for="name">이름</label>
    <input name="author[name]" id="name" type="text" value="<?=$author['name'] ?? ''?>">

    <label for="password">패스워드</label>
    <input name="author[password]" id="password" type="password" value="<?=$author['password'] ?? ''?>">

    <input type="submit" name="submit" value="사용자 등록">    
</form>