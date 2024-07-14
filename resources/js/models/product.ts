import {Department} from "@/models/department";
import {Material} from "@/models/material";

export interface Product {
    id: number,
    name: string,
    price: number,
    department: Department,
    materials: Material[]
}

export class InputProduct {
    name: string = ""
    price: number = 0
    department_id: number = 0
    materials_id: number[] = []
}
