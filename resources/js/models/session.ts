export interface Session {
    id: string,
    ip_address: string,
    last_activity: number,
    user_agent: string
}

export interface UAParsed {
    os: {
        name: string,
        version: string
    },
    browser: {
        name: string,
        version: string
    },
}
