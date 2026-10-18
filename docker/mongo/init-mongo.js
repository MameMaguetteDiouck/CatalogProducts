db = db.getSiblingDB('admin');

db.auth(
    process.env.MONGO_INITDB_ROOT_USERNAME || 'admin',
    process.env.MONGO_INITDB_ROOT_PASSWORD || 'admin_secret_password'
);

const targetDb = db.getSiblingDB(process.env.MONGO_INITDB_DATABASE || 'catalog_db');

targetDb.createUser({
    user: process.env.MONGODB_USER || 'catalog_user',
    pwd: process.env.MONGODB_PASSWORD || 'catalog_secret',
    roles: [
        {
            role: 'readWrite',
            db: process.env.MONGO_INITDB_DATABASE || 'catalog_db'
        }
    ]
});
