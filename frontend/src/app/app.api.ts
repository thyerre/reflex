import {environment} from "../environments/environment"
export const API = environment.api
let WithoutApi = ''; 
if (environment.production) {
    WithoutApi = API.split('br/api')[0]+'br'; 
} else {
    WithoutApi = API.split('/api')[0]; 
}
export const APIWithoutApi = WithoutApi; 
export const API_PATH_IMG = APIWithoutApi+'/img'
export const SERVER_ND = 'http://localhost:3099'