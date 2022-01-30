import store from 'store';
import { AUTH_STORAGE_KEY } from '../constants';
import authRoutes from "./auth-routes";
import userRoutes from "./user-routes";
import publicRoutes from "./public-routes";

const auth = store.get(AUTH_STORAGE_KEY);
const isLoggedIn = auth?.isLoggedIn;

const routes = [
    ...publicRoutes(isLoggedIn),
    ...authRoutes(isLoggedIn),
    ...userRoutes(isLoggedIn)
]

export default routes;
