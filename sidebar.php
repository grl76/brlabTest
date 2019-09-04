<?php $terms = get_terms( 'typeBet', array('hide_empty' => false) ); ?>
<div class="sidebar">
    <h4>Создать ставку</h4>
    <div class="box">
        <input id="betName" type="text" placeholder="Заголовок" />
        <textarea id="betContent" placeholder="Описание"></textarea>
        <select>
            <?php foreach($terms as $term): ?>
                 <option value="<?= $term->term_id; ?>"><?= $term->name; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" id="createBet" />
    </div>

</div>
<?php
