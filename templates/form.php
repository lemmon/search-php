<div class="p05">
  <form action="<?= htmlspecialchars(Eyca\config()['self']) ?>" method="get">
    <div class="row p025">
      <?php if (!isset(Eyca\config()['search']['country'])): ?>
      <label class="p0125">
        <div class="p0125">Country</div>
        <div class="p0125">
          <select name="country">
            <option></option>
            <?php foreach ($data['options']['countries'] as $_country): ?>
            <option
              value="<?= $_country['id'] ?>"
              <?php if (Eyca\formdata()['country'] === $_country['id'] and !Eyca\formdata()['region']): ?>selected<?php endif ?>
            ><?= $_country['name'] ?></option>
            <?php if (isset($_country['regions']) and !isset(Eyca\config()['search']['region'])): ?>
            <?php foreach ($_country['regions'] as $_region): ?>
            <option
              value="<?= $_country['id'] ?> <?= $_region ?>"
              <?php if (Eyca\formdata()['country'] === $_country['id'] and Eyca\formdata()['region'] === $_region): ?>selected<?php endif ?>
            > - <?= $_region ?></option>
            <?php endforeach ?>
            <?php endif ?>
            <?php endforeach ?>
          </select>
        </div>
      </label>
      <?php endif ?>
      <?php if (!isset(Eyca\config()['search']['category'])): ?>
      <label class="p0125">
        <div class="p0125">Category</div>
        <div class="p0125">
          <select name="category">
            <option></option>
            <?php foreach ($data['options']['categories'] as $_category): ?>
            <option
              value="<?= $_category['id'] ?>"
              <?php if (Eyca\formdata()['category'] === $_category['id']): ?>selected<?php endif ?>
            ><?= $_category['name'] ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </label>
      <?php endif ?>
      <?php if (!isset(Eyca\config()['search']['tag'])): ?>
      <label class="p0125">
        <div class="p0125">Tag</div>
        <div class="p0125">
          <select name="tag">
            <option></option>
            <?php foreach ($data['options']['tags'] as $_tag): ?>
              <option
                <?php if (Eyca\formdata()['tag'] === $_tag): ?>selected<?php endif ?>
              ><?= $_tag ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </label>
      <?php endif ?>
    </div>
    <div class="row justify-start items-center">
      <div class="p025"><button type="submit">Search</button></div>
      <?php if (!empty(Eyca\formdata()['country'])
        or !empty(Eyca\formdata()['region'])
        or !empty(Eyca\formdata()['category'])
        or !empty(Eyca\formdata()['tag'])): ?>
      <div class="p025"><a class="f2 ul" href="<?= htmlspecialchars(explode('?', Eyca\config()['self'])[0]) ?>">reset</a></div>
      <?php endif ?>
    </div>
  </form>
</div>