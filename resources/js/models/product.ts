import {Department} from "@/models/department";
import {Material} from "@/models/material";

export interface Product {
    id: number,
    name: string,
    price: number,
    department: Department,
    materials: Material[]
}
