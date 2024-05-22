export interface Pagination<T> {
    current_page: number,
    data: T[],
    per_page: number,
    total: number,
    from: number,
    to: number,
    last_page: number,
    last_page_url: string,
    next_page_url: string,
    prev_page_url: string,
    first_page_url: string,
    path: string,
    links: {
        active: boolean,
        label: number,
        url: string
    }[]
}
