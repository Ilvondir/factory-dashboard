import {User} from "./user";
import {Action} from "./action";

export interface Log {
    id: number,
    operation: string,
    occured: Date,
    user: User,
    action: Action
}
