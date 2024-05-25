import {Position} from "@/models/position";

export interface Worker {
    id: number
    first_name: string
    last_name: string
    salary: number
    email: string
    phone_number: string
    address: string
    hired: string
    position: Position
}

export class InputWorker {
    first_name: string = ""
    last_name: string = ""
    salary: number = 0.0
    email: string = ""
    phone_number: string = ""
    address: string = ""
    position_id: number = 0
}
