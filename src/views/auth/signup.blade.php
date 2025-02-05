<div class="container">
    <div class="background">
        <div class="row justify-content-center">
            <div>
                <form action="/user/register" method="POST">
                    <h2>Sign Up</h2>
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" maxlength="30" required
                               placeholder="example@gmail.com"/>
                        <label for="password">Password:</label>
                        <input type="password" id="password" maxlength="255" name="password" class="form-control"
                               required/>
                        <label for="confirm-password">Confirm Password:</label>
                        <input type="password" id="confirm-password" maxlength="255" name="confirm-password"
                               class="form-control" required/>
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Sign Up</button>

                </form>
            </div>
        </div>
    </div>
</div>