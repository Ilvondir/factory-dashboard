export interface Material {
    id: number,
    name: string,
    amount: number,
    created_at: Date;
    updated_at: Date;
}

export class InputMaterial {
    name: string = ""
    amount: number = 0
}
