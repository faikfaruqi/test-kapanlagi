<p class='title'>Profile</p>
  <main class='content'>
    <section id='profile'>
      <form id='formUpdate' name="formUpdate">
        <ul>
          <li class='large padding avatar'>
          <?php
            echo '<span id="imagePreview" style="background-image: url('.$viewModel['image']['240x240'].');"></span>';
          ?>
            <div>
              <fieldset class='material-button'>
                <div>
                  <span class='material-file'>browse</span><input class='file' type='file' name='image' id='image' accept=".jpg, .jpeg">
                </div>
              </fieldset>
            </div>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='name' id='name' value="<?=$viewModel['nama']?>">
                <label for="name">Name</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='birthdate' id="birthdate" value="<?=substr($viewModel['tgl_lahir'],0,10)?>">
                <label>Birth Date (YYYY-MM-DD)</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='address' id='address' value="<?=$viewModel['alamat']?>">
                <label>Address</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='hidden' name='id' id='id' value="<?=$viewModel['id']?>">
                <input required type='text' name='email' id='email' value="<?=$viewModel['email']?>">
                <label>Email</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li class='large padding'>
            <fieldset class='material-button center'>
              <div>
                <input class='save' type='submit' value='Save'>
              </div>
            </fieldset>
          </li>
          <p class='message' id='message'></p>
        </ul>
      </form>
    </section>
  </main>