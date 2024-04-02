// myStore.ts
import {createStore} from 'vuex';
import {handleServerError, handleSuccess, handleWarning} from "@/main";

export default {
    state: {
        // Khởi tạo state nếu cần thiết
    },
    mutations: {
        // Định nghĩa mutations nếu cần thiết
    },
    actions: {
        handleServerError() {
            // Hiển thị Toast
            handleServerError();
        },
        handleSuccess(context: any, message: any) {
            handleSuccess({message: message})
        },
        handleWarning(context: any, message: any) {
            handleWarning({message: message})
        }

    },
    getters: {
        // Định nghĩa getters nếu cần thiết
    }
};
