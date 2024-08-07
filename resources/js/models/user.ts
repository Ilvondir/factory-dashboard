import {Role} from "../models/role";

export interface User {
    id: number,
    first_name: string,
    last_name: string,
    email: string,
    role: Role
}

export class InputUser {
    first_name: string = ""
    last_name: string = ""
    email: string = ""
    role_id: number = 0
}


export class InputPasswordChange {
    old_password: string = ""
    password: string = ""
    password_confirmation: string = ""
}
