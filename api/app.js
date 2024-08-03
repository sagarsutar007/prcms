const express = require("express");
const helmet = require("helmet");
const cors = require("cors");
const compression = require("compression");
const app = express();
const port = 3000;
const authRouter = require("./routes/authRouter");

// Use Helmet for security
app.use(helmet());

// Disable 'X-Powered-By' header
app.disable("x-powered-by");

// Enable CORS
app.use(cors());
app.use(compression());
app.use(express.json());
app.use("/api", authRouter);

app.get("/", (req, res) => {
	res.send("Hello World!");
});

app.listen(port, () => {
	console.log(`Server is running on http://localhost:${port}`);
});
