<div class="upload">
    
    <form action="<?= BASEURL ?>/Clouds/result" method="post" enctype="multipart/form-data">
        <div id="file-upload-container">
            <ul id="staged-files"></ul>
        </div>
        <br>
        <label for="codename">codename: </label>
        <input type="text" id="codename" name="codename" required>
        <br>
        <br>
        <input type="hidden" name="token" value="<?= UP_TOKEN ?>">
        <input type="submit" name="submit" value="Upload">
    </form>
</div>