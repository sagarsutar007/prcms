import CryptoJS from "crypto-js";

const SECRET_KEY = process.env.SECRET_KEY;

export const encrypt = (text) => {
	if (typeof text !== "string") {
		text = String(text);
	}
	return CryptoJS.AES.encrypt(text, SECRET_KEY).toString();
};

export const decrypt = (cipherText) => {
	if (typeof cipherText !== "string") {
		throw new Error("Input must be a string");
	}
	const bytes = CryptoJS.AES.decrypt(cipherText, SECRET_KEY);
	const decryptedText = bytes.toString(CryptoJS.enc.Utf8);
	return decryptedText;
};
