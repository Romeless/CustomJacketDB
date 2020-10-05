<div id="designs">
    <br>
    <p>
        GET: /todo/api/0.1/order
        
        OUTPUT:
        -> ARRAY OF [userID,designID,username,address,email,qty,status,price,phoneNumber,information,partnership,partnerAddress]
    </p>
    <p>
        POST: /todo/api/0.1/order/create
        INPUT:
        -> userID,designID,qty,price,information
        --> address,phoneNumber

        OUTPUT:
        -> INPUT + username,email
    </p>
    <p>
        PUT: todo/api/0.1/order/update/(id)
        INPUT:
        -> userID,designID,qty,price,information
        --> address,phoneNumber

        OUTPUT:
        -> INPUT + id
    </p>
    <p>
        GET: todo/api/0.1/order/show/(id)

        OUTPUT:
        -> userID,designID,username,address,email,qty,status,price,phoneNumber,information,partnership,partnerAddress
    </p>
    <p>
        POST: todo/api/0.1/order/user/(userID)

        OUTPUT:
        -> ARRAY [userID,designID,username,address,email,qty,status,price,phoneNumber,information,partnership,partnerAddress]
    </p>
    <p>
        POST: todo/api/0.1/order/user/(designID)

        OUTPUT:
        -> ARRAY [userID,designID,username,address,email,qty,status,price,phoneNumber,information,partnership,partnerAddress]
    </p>
    <br>
</div>