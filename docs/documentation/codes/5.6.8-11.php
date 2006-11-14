[id]
accessor = "getId"
mutator = "setId"
once = true

[parent_id]
accessor = "getParentId"
mutator = "setParentId"

[comment]
accessor = "getComments"
mutator = "setComments"

hasMany = "id->comments.folder_id"