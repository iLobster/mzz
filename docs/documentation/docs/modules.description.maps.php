<p>Пример типичного map-файла:</p>
<<code ini>>
[id]
accessor = "getId"
mutator = "setId"
once = true

[title]
accessor = "getTitle"
mutator = "setTitle"

[editor]
accessor = "getEditor"
mutator = "setEditor"
owns = "user.id"
module = "user"
section = "user"

[text]
accessor = "getText"
mutator = "setText"

[folder_id]
accessor = "getFolderId"
mutator = "setFolderId"

[created]
accessor = "getCreated"
mutator = "setCreated"
once = true

[updated]
accessor = "getUpdated"
mutator = "setUpdated"
once = true
<</code>>