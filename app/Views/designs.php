<div id="designs">
<br>
    <p>
        GET: /todo/api/0.1/designs
        
        OUTPUT:
        -> ARRAY OF [userID,designName,details,images,imagesPosition,information,createDate,updateDate]
    </p>
    <p>
        POST: /todo/api/0.1/designs/create
        INPUT:
        -> userID,designName,details
        --> images,imagesPosition,information

        OUTPUT:
        -> INPUT
    </p>
    <p>
        PUT: todo/api/0.1/designs/update/(id)
        INPUT:
        -> userID,designName,details
        --> images,imagesPosition,information
        
        OUTPUT:
        -> INPUT + id
    </p>
    <p>
        PUT: todo/api/0.1/designs/delete/(id)
    </p>
    <p>
        PUT: todo/api/0.1/designs/remove/(id)
        INPUT:
        -> userID
        
        OUTPUT:
        -> INPUT + id
    </p>
    <p>
        GET: todo/api/0.1/designs/show/(id)

        OUTPUT:
        -> userID,designName,details,images,imagesPosition,information,createDate,updateDate,price
    </p>
    <p>
        POST: todo/api/0.1/designs/user/(userID)

        OUTPUT:
        -> ARRAY OF [userID,designName,details,images,imagesPosition,information,createDate,updateDate,price,username]
    </p>

    <br>
</div>