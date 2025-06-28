import ResourceService from './ResourceService'

interface Login {
    email: string;
    password: string;
}

class LoginService extends ResourceService<Login> {
    constructor() {
        super('auth/login');
    }
}

export default LoginService;
