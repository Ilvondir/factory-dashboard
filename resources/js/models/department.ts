import {Position} from "@/models/position";

export interface Department {
    id: number,
    name: string,
    positions: Position[]
}


export class InputDepartment {
    name: string = ""
}
