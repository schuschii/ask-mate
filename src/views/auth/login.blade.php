<div>
    <form action="/user/login" method="POST">
        <h2>Login</h2>
        <div>
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" maxlength="30" required
                   placeholder="example@gmail.com"/>
            <label for="password">Password:</label>
            <input type="password" id="password" maxlength="255" name="password" class="form-control"
                   required/>
        </div>
        <button type="submit">Login</button>
    </form>
</div>
