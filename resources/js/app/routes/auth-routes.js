import {Navigate} from "react-router-dom";
import Login from "../view/Login";
import Register from "../view/Register";

const authRoutes = (isLoggedIn)=>{
    return [
        {
            path: '/auth/login',
            element: <Login />
        },
        {
            path: '/auth/register',
            element: <Register />
        },
    ]
}

export default authRoutes;
