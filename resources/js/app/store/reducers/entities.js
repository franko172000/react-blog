import { combineReducers } from "redux";
import userReducer from '../entities/user'

export default combineReducers({
    user: userReducer
})
