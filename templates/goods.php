<?php
$itemStatus = $item['data_start'] <= date("Y-m-d") && date("Y-m-d") <= $item['data_end'];

$link = mysqli_connect("localhost", "root", "root", "coursework");
?>

<div class="container">
    <div class="good-page">
        <div class="goods__item">
            <div class="goods__item-image-block">
                <a class="goods__item-link" href="/goods.php?id=<?= $item['id'] ?>">
                    <img alt="<?= $item['title'] ?>" title="<?= $item['title'] ?>" class="goods__item-img" src="img/goods/<?= $item['id'] ?>.png" alt="img">
                </a>
            </div>
            <div class="goods__item-content">
                <a class="goods__item-title" href="/goods.php?id=<?= $item['id'] ?>">
                    <?= $item['title'] ?>
                </a>

                <?php if (isset($item['bonuses']) && $item['bonuses'] !== 0 && $itemStatus && $count > 0) : ?>
                    <div class="goods__item-bonus" style="margin-top: 10px">
                        Бонусы за покупку:
                        <span><?= $item['bonuses'] ?></span>
                    </div>
                <?php endif; ?>

                <div class="goods__item-footer">
                    <div class="goods__item-price">
                        <?php if ($count > 0) : ?>
                            <span><?= $itemStatus ? $item['price'] * ((100 - $item['discount']) / 100) : $item['price'] ?>&#8381;</span>
                            <?php if (isset($item['discount']) && $item['discount'] !== 0 && $itemStatus) : ?>
                                <span><?= $item['price'] ?>&#8381;</span>
                            <?php endif; ?>
                        <?php else : ?>
                            <span><?= $item['price'] ?>&#8381;</span>
                        <?php endif; ?>
                    </div>

                    <button type="button" class="goods__item-btn" data-id="<?= $item['id'] ?>" data-title="<?= $item['title'] ?>" data-price="<?= $item['price'] ?>" data-description="<?= $item['description'] ?>">
                        Купить
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="good-comment d-flex justify-content-between">
        <h2 class="good-comment__title">Комментарии</h2>
        <button type="button" class="btn btn-primary mt-0" data-bs-toggle="modal" data-bs-target="#commentModal">Оставить комментарий</button>
    </div>
    <div class="good-comment__block">
        <?php foreach ($comments as $com) : ?>
            <?php
            $sql = "SELECT COUNT(*) FROM com_rewiew WHERE id_user = ? AND id_com = ?";
            $count_com = db_fetch_data($link, $sql, [$_SESSION['user']['id'], $com['id']])[0]["COUNT(*)"];

            $sql = "SELECT COUNT(*) FROM com_child WHERE id_com_child = ?";
            $isChild = db_fetch_data($link, $sql, [$com['id']])[0]["COUNT(*)"];
            ?>

            <?php if ($isChild < 1) : ?>
                <div class="good-comment__block-item">
                    <div class="good-comment__block-item-name">
                        <?= $com['username'] ?>
                    </div>
                    <p>
                        <?= $com['text_comment'] ?>
                    </p>
                    <div class="d-flex justify-content-end">
                        <button data-idcom="<?= $com['id'] ?>" type="button" class="mt-0 me-4 childModal" data-bs-toggle="modal" data-bs-target="#commentChildModal">Ответить</button>
                        <div class="d-flex align-items-center me-2">
                            <a href="/goods.php?id=<?= $item['id'] ?>&like=<?= $com['id'] ?>" class="good-comment__btn me-1"></a>
                            <span><?= $com['like_comment'] ?></span>
                        </div>
                        <div class="d-flex align-items-center">
                            <a href="/goods.php?id=<?= $item['id'] ?>&dislike=<?= $com['id'] ?>" class="good-comment__btn good-comment__btn--reverse me-1"></a>
                            <span><?= $com['dislike_comment'] ?></span>
                        </div>
                    </div>
                </div>

                <?php
                $sql = "SELECT com.id, u.username, com.text_comment, com.like_comment, com.dislike_comment from comments com join users u on u.id = com.id_user join com_child ch on ch.id_com_child = com.id WHERE com.id_good = ? AND ch.id_com = ?";
                $com_child = db_fetch_data($link, $sql, [$_GET['id'], $com['id']]);
                ?>
                <div class="ms-5">
                    <?php foreach ($com_child as $child) : ?>
                        <?php
                        $sql = "SELECT COUNT(*) FROM com_rewiew WHERE id_user = ? AND id_com = ?";
                        $count_com = db_fetch_data($link, $sql, [$_SESSION['user']['id'], $child['id']])[0]["COUNT(*)"];
                        ?>
                        <div class="">
                            <div class="good-comment__block-item-name">
                                <?= $child['username'] ?>
                            </div>
                            <p>
                                <?= $child['text_comment'] ?>
                            </p>
                            <div class="d-flex justify-content-end">
                                <div class="d-flex align-items-center me-2">
                                    <a href="/goods.php?id=<?= $item['id'] ?>&like=<?= $child['id'] ?>" class="good-comment__btn me-1"></a>
                                    <span><?= $child['like_comment'] ?></span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <a href="/goods.php?id=<?= $item['id'] ?>&dislike=<?= $child['id'] ?>" class="good-comment__btn good-comment__btn--reverse me-1"></a>
                                    <span><?= $child['dislike_comment'] ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<!-- модальные окна -->
<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="/goods.php?id=<?= $item['id'] ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Оставить комментарий</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Введите текст комментария</label>
                    <textarea class="form-control rounded-0 mt-2" name="commentContent" id="exampleFormControlTextarea1" placeholder="Введите текст собщения" rows="10" required minlength="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mt-0">Оставить</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="commentChildModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="/goods.php?id=<?= $item['id'] ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Оставить комментарий</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input id="inputHidden" type="hidden" value="" name="idcom" />
            <div class="modal-body">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Введите текст комментария</label>
                    <textarea class="form-control rounded-0 mt-2" name="commentContent" id="exampleFormControlTextarea1" placeholder="Введите текст собщения" rows="10" required minlength="10"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary mt-0">Оставить</button>
            </div>
        </form>
    </div>
</div>
