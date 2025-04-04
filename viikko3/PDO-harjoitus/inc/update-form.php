<section id="update-media-item">
    <!--suppress HtmlUnknownTarget -->
    <form action="./operations/updateData.php" method="post">
        <div class="form-control">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title"/>
        </div>
        <div class="form-control">
            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5"></textarea>
        </div>
        <input type="hidden" name="user_id" value="1">
        <button type="submit">Upload Image</button>
    </form>
</section>