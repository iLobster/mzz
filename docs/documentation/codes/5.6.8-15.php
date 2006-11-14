[id]
accessor = "getId"
mutator = "setId"
once = true

[text]
accessor = "getText"
mutator = "setText"

[author]
accessor = "getAuthor"
mutator = "setAuthor"

owns = "user.id"
section = "user"
module = "user"


[time]
accessor = "getTime"
mutator = "setTime"

[folder_id]
accessor = "getFolder"
mutator = "setFolder"

owns = "commentsFolder.id"