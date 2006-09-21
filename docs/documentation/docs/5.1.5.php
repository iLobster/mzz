Пример типичного map-файла:<br />
<div class="code"><code>
        [id]<br />
        accessor = "getId"<br />
        mutator = "setId"<br />
        once = true<br />
        <br />
        [title]<br />
        accessor = "getTitle"<br />
        mutator = "setTitle"<br />
        <br />
        [editor]<br />
        accessor = "getEditor"<br />
        mutator = "setEditor"<br />
        owns = "user.id"<br />
        module = "user"<br />
        section = "user"<br />
        <br />
        [text]<br />
        accessor = "getText"<br />
        mutator = "setText"<br />
        <br />
        [folder_id]<br />
        accessor = "getFolderId"<br />
        mutator = "setFolderId"<br />
        <br />
        [created]<br />
        accessor = "getCreated"<br />
        mutator = "setCreated"<br />
        once = true<br />
        <br />
        [updated]<br />
        accessor = "getUpdated"<br />
        mutator = "setUpdated"<br />
        once = true
</code></div>