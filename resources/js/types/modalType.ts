interface ModalType {
    container: HTMLElement | null;
    open(type: any | null): void;
    isOpen: boolean;
    close(): void;
    autoCloser(val: any): void;
    switch(val: boolean): Promise<boolean>;
    type: string;
    class: String;
    data: object;
    background: boolean;
    redirect: string;
    auth(): void;
    reset(): void;
}

export default ModalType;
