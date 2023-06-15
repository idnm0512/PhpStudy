<p>
    <?=$totalJokes?>개 유머 글이 있습니다.
</p>
<?php foreach ($jokes as $joke): ?>
    <blockquote>
        <p>
            <?=htmlspecialchars($joke['joketext'], ENT_QUOTES, 'UTF-8')?>

            (작성자:
            <a href="mailto:<?php echo htmlspecialchars($joke['email'], ENT_QUOTES, 'UTF-8') ?>">
                <?php echo htmlspecialchars($joke['name'], ENT_QUOTES, 'UTF-8') ?></a>
            작성일: <?=$joke['jokedate']?>)
                
            <a href="editjoke.php?id=<?=$joke['id']?>">수정</a>
        </p>
        <form action="deletejoke.php" method="post">
            <input type="hidden" name="id" value="<?=$joke['id']?>">
            <input type="submit" value="삭제">
        </form>
    </blockquote>
<?php endforeach; ?>