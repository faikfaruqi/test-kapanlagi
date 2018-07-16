<p class='title'>Profile</p>
  <main class='content'>
    <section id='profile'>
      <form id='form' name='form'>
        <ul>
          <li class='large padding avatar'>
            <span id='imagePreview' style="background-image: url('public/img/user.png');"></span>
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
                <input required type='text' name='name' id='name'>
                <label for="name">Name</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='birthdate' id="birthdate">
                <label>Birth Date (YYYY-MM-DD)</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='address' id='address'>
                <label>Address</label>
                <hr>
              </div>
            </fieldset>
          </li>
          <li>
            <fieldset class='material'>
              <div>
                <input required type='text' name='email' id='email'>
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
      <div class='profile'>
        <ul id='scroll'>
        </ul>
      </div>
    </section>
  </main>