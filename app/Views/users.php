<div id="users'">
    <br>
    <p>
        GET: /todo/api/0.1/users
        
        OUTPUT:
        -> ARRAY OF [username,fullName,tokenID,email,password,salt,avatar,address,phoneNumber,verified,joinDate,lastLogin]
    </p>
    <p>
        POST: /todo/api/0.1/users/create
        INPUT:
        -> username,fullName,password,email
        --> avatar,address,phoneNumber

        OUTPUT:
        -> INPUT + salt,joinDate
    </p>
    <p>
        POST: todo/api/0.1/users/googleAuth
        INPUT:
        -> tokenID,fullName,email,googleID
        --> device

        OUTPUT:
        -> id,token,userID,device,createDate,expireDate,username
    </p>
    <p>
        PUT: todo/api/0.1/users/update/(id)
        INPUT:
        -> username,fullName,password,email
        --> avatar,address,phoneNumber

        OUTPUT:
        -> INPUT + id
    </p>
    <p>
        GET: todo/api/0.1/users/show/(id)

        OUTPUT:
        -> username,fullName,tokenID,email,password,salt,avatar,address,phoneNumber,verified,joinDate,lastLogin
    </p>
    <p>
        POST: todo/api/0.1/users/login
        INPUT:
        -> username,password

        OUTPUT:
        -> token,userID,username,device,createDate,expireDate
    </p>
    <p>
        POST: todo/api/0.1/users/user
        INPUT:
        -> username

        OUTPUT:
        -> username,fullName,tokenID,email,password,salt,avatar,address,phoneNumber,verified,joinDate,lastLogin
    </p>
    <br>
</div>