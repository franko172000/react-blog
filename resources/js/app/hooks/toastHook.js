import { useToasts } from 'react-toast-notifications';
export const useToast = ()=>{
    const { addToast } = useToasts();
    return (type,message)=>{
        addToast(message, 
            { 
                appearance: type,
                autoDismiss: true
            });     
    }
}