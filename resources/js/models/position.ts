import {type Department} from "./department";
import {type Worker} from "./worker";

export interface Position {
    id: number
    name: string
    responsibilities: string
    department: Department
    workers: Worker[]
}

export class InputPosition {
    name: string = ""
    responsibilities: string = ""
    department: number = 0
}
