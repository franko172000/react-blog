import { useToast } from "./toastHook";
export const useHttpError = ()=>{
    const toast = useToast();
    return (err, customMessage = null)=>{
        const {data, status} = err.response;
        const msg = customMessage ?? data.message;
        if(status === 500){
            toast('error',customMessage ?? "There was an error submiting the form. Please try again later")
        }
        if(status === 422){
            toast('error', data.errorCode === 'VALIDATION_ERROR' ? data.errors[0] : msg)
        }
        if(status === 400){
            toast('error',msg)
        }
        if(status === 404){
            toast('error',msg)
        }
        if(status === 419){
            toast('error',msg)
        }
        if(status === 401){
            toast('error',msg)
        }
    }
}
