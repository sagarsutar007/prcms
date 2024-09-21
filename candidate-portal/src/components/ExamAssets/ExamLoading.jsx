
const ExamLoading = () => (
    <div className="overlay" style={{
        display: "flex",
        alignItems: "center",
        justifyContent: "center",
        height: "100vh"
    }}>
        <div className="spinner-border text-primary" role="status">
            <span className="visually-hidden">Loading...</span>
        </div>
    </div>
);

export default ExamLoading;
