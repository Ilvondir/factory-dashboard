export interface Material {
    id: number,
    name: string,
    amount: number,
    added: Date;
}

export class InputMaterial {
    name: string = ""
    amount: number = 0
}
