import ResourceService from './ResourceService'
import { User } from '../types/user'

class UserService extends ResourceService<User> {
    constructor() {
        super('user');
    }
}

export default UserService;
