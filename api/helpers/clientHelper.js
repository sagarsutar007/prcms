const useragent = require("useragent");
const getClientType = (userAgent) => {
	const agent = useragent.parse(userAgent);
	if (agent.device.toString().toLowerCase().includes("mobile")) {
		return "phone";
	}
	return "computer";
};
module.exports = { getClientType };
