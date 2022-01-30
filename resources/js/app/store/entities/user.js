import { createSlice } from "@reduxjs/toolkit";
import store from 'store'
import { AUTH_STORAGE_KEY } from "../../constants";

const auth = store.get(AUTH_STORAGE_KEY)

const slice = createSlice({
    name: 'user',
    initialState: auth?.user || {},
    reducers:{
        userLoaded:(user, action)=>{
            const {
                firstName,
                lastName,
                email,
                userType
            } = action.payload

            user.firstName = firstName
            user.lastName = lastName
            user.email = email
            user.userType = userType
        }
    }
});

export const {userLoaded} = slice.actions;
export default slice.reducer;
